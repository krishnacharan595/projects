from flask import  render_template, request, redirect,session,url_for
import os
import matplotlib.pyplot as plt
from flask import current_app as app
from Database.database import *
from datetime import date, timedelta



@app.route('/', methods=["GET", "POST"])
def U_login():
    if request.method=="GET":
        return render_template("U_login.html")
    elif request.method=="POST":
        button=request.form.get('button')
        if button=='login':
            uname=request.form['uname']
            paswd=request.form['paswd']
            user = User.query.filter_by(name = uname).first()
            if user:
                if user.password==paswd:
                    session['logged_in'] = True  
                    session['user_id'] = user.id
                    session['user']=user.name
                    return redirect('/home')  
                else:
                    url=url_for('U_login')
                    return render_template('alert.html', msg='Invalid credentials',ret=url,button='return to login')
            else:
                url=url_for('U_login')
                return render_template('alert.html', msg='No User Found!',ret=url,button='return to login')
        elif button=='register':
            return redirect('/register')
        elif button=='admin':
            return redirect('/Alogin')

@app.route('/Alogin', methods=["GET", "POST"])
def A_login():
    if request.method=="GET":
        return render_template("A_login.html")
    elif request.method=="POST":
        button=request.form.get('button')
        if button=='login':
            uname=request.form['uname']
            paswd=request.form['paswd']
            user = User.query.filter_by(name = uname).first()
            if user:
                if user.password==paswd:
                    if user.admin:
                        session['logged_in'] = True  
                        session['user_id'] = user.id
                        session['user']=user.name
                        return redirect('/A_dashboard')  
                    else:
                        url=url_for('A_login')
                        return render_template('alert.html', msg='Access Denied',ret=url,button='return to login')
                else:
                    url=url_for('A_login')
                    return render_template('alert.html', msg='Invalid credentials',ret=url,button='return to login')
            else:
                url=url_for('A_login')
                return render_template('alert.html', msg='No User Found!',ret=url,button='return to login')
        else:
            url=url_for('U_login')
            return redirect(url)

@app.route('/register', methods=["GET", "POST"])
def register():
    if request.method=="GET":
        return render_template("register.html")
    elif request.method=="POST":
        uname=request.form['name']
        paswd=request.form['paswd']
        dob=request.form['dob']
        mail=request.form['mail']
        telnum=request.form['telnum']
        gender=request.form['gender']
        new_user = User(name=uname,password=paswd,telnum=telnum,gender=gender,mail=mail,dob=dob)
        db.session.add(new_user)
        db.session.commit()
        db.session.close
        url=url_for('U_login')
        return render_template('alert.html', msg='Registration Success',ret=url,button='return to login')

@app.route('/home', methods=["GET", "POST"])
def home():
    if 'user_id' not in session:
        return redirect('/')
    if request.method=="GET":
        prod = Product.query.order_by(Product.id.desc()).all()
        category=Category.query.order_by(Category.id.desc()).all()
        return render_template("home.html",category=category,product=prod,user=session['user'])
    else:
        search_term=request.form.get('search')
        if search_term!='':
            query = Product.query.filter(or_(
            cast(Product.price,String).ilike((f"{search_term}")),
            Product.name.ilike(f"%{search_term}%"),  
            Product.dom.ilike(f'%{search_term}%'),
            Product.category.ilike(f"%{search_term}%")  
        ))
            results = query.all()
            category =db.session.query(Category).filter(Category.category.in_(list(set([result.category for result in results])))).all()
            return render_template('home.html',category=category,product=results,user=session['user'])
        else:
            prod = Product.query.order_by(Product.id.desc()).all()
            category=Category.query.order_by(Category.id.desc()).all()
            return render_template('home.html',category=category,product=prod,user=session['user'])


@app.route('/Dashboard', methods=["GET", "POST"])
def Dashboard():
    user=User.query.filter_by(id=session['user_id']).first()
    return render_template('U_dashboard.html',name=user.name)

@app.route('/add_to_cart', methods=["GET", "POST"])
def add_to_Cart():
    product_name = request.form.get('prod_name')
    session['cart']=session.get('cart',[])
    prod=Product.query.filter_by(name=product_name).first()
    stock=prod.stock
    qunt=int(request.form.get('qunt'))
    item = {'id':prod.id,'name': prod.name,'stock': prod.stock,'price': prod.price, 'category': prod.category,'quantity': qunt}
    if stock>=qunt:
        session['cart'].append(item)
        new_stock=stock-qunt
        prod.stock=new_stock
        db.session.commit()
        return redirect('/home')
    else:
        url=url_for('home')
        return render_template('alert.html', msg='Low on stock!',ret=url,button='return to home') 
    
@app.route('/Checkout', methods=['GET','POST'])
def checkout():
    try:
        cart=session['cart']
        grand_total=0
        for i in cart:
            grand_total+=i['price']*i['quantity']
        session.get('total')
        return render_template('review.html',cart=cart,grand_total=grand_total)
    except:
        url=url_for('home')
        return render_template('alert.html', msg='cart is empty!',ret=url,button='return to home') 

@app.route('/change', methods=['POST'])
def changea():
    cart = session['cart']
    for i in cart:
        if request.form.get(str(cart.index(i)+1)):
            prod=Product.query.filter_by(id=i['id']).first()
            add = Purchase(p_id=i['id'],category=i['category'],price=prod.price,count=i['quantity'],user_id=session['user_id'])
            db.session.add(add)
            db.session.commit()
            db.session.close    
    session.pop('cart', None)
    url=url_for('home')
    return render_template('alert.html', msg='order palced Successfully',ret=url,button='return to home')
    
@app.route('/admin', methods=['GET','POST'])
def admin():
    try:
        if request.method=='GET':
            return redirect('A_dashboard')
        else:
            user=User.query.filter_by(id=session['user_id']).first()
            if user.admin:
                cat=Category.query.all()
                if request.form.get('manage')=='Add':
                    return render_template('management.html',oper='Add',category=request.form.get('category'))     
                elif request.form.get('manage')=='del':
                    return redirect(url_for('delete_prod',id=request.form.get('id')))  
                elif request.form.get('manage')=='Edit':
                    return render_template("management.html",oper='Edit',cat=cat,id=request.form.get('id'))
                elif request.form.get('manage')=='Add_cat':
                    return render_template("management.html",oper="Add_cat")        
                elif request.form.get('manage')=='del_cat':
                    return redirect(url_for('delete_cat',id=request.form.get('cat_id')))
                elif request.form.get('manage')=='Edit_cat':
                    return render_template("management.html",oper='Edit_cat',id=request.form.get('id'))
            else:
                url=url_for('logout')
                return render_template('alert.html', msg='Access Denied,try logout and re-login',ret=url,button='logout')
    except:
        url=url_for('A_login')
        return render_template('alert.html', msg='Access Denied,login',ret=url,button='login')

@app.route('/add_product', methods=['GET','POST'])
def add_prod():
    try:
        name= request.form.get('name')
        prod=Product.query.filter_by(name=name).first()
        if prod==None:
            add = Product(units=request.form.get('units'),dom=request.form.get('dom'),name=name,stock=request.form.get('stock'),price=request.form.get('price'),category=request.form.get('category'))
            if request.method == 'POST':
                uploaded_file = request.files['file']
                des= os.path.abspath('Code')
                if uploaded_file.filename != '':
                    uploaded_file.save (des+"\static\\"+request.form.get('name')+".png")
            db.session.add(add)
            db.session.commit()
            db.session.close  
            url=url_for('A_dashboard')
            return render_template('alert.html', msg= 'product added Successfully',ret=url,button='return to admin Dashboard')
        else:
            url=url_for('A_dashboard')
            return render_template('alert.html', msg= 'product already exist',ret=url,button='return to admin Dashboard')
    except:
        url=url_for('A_dashboard')
        return render_template('alert.html', msg= 'Something went wrong try again!',ret=url,button='return to admin Dashboard')

@app.route('/del_product/<id>', methods=['GET','POST'])
def delete_prod(id):
    url=url_for('A_dashboard')
    prod=Product.query.filter_by(id=id).first()
    prod = db.session.query(Product).filter_by(id=id).first()
    db.session.delete(prod)
    db.session.commit()
    db.session.close    
    url=url_for('A_dashboard')
    return render_template('alert.html', msg= 'product deleted Successfully',ret=url,button='return to admin Dashboard')

@app.route('/edit_product', methods=['GET','POST'])
def edit_prod():
    prod=Product.query.filter_by(id=request.form.get('id')).first()
    name=request.form.get('name')
    prod.name=name
    prod.stock=request.form.get('stock')
    prod.category=request.form.get('category')
    prod.price=request.form.get('price')
    db.session.commit()
    db.session.close  
    url=url_for('A_dashboard')
    return render_template('alert.html', msg= 'product edited Successfully',ret=url,button='return to admin Dashboard')

@app.route('/add_category', methods=['GET','POST'])
def add():
    name=request.form.get('name')
    type=request.form.get('type')
    prod=Category.query.filter_by(category=name).first()
    if prod==None:
        add = Category(category=name,type=type)
        if request.method == 'POST':
            db.session.add(add)
            db.session.commit()
            db.session.close  
        url=url_for('A_dashboard')
        return render_template('alert.html', msg= 'category added Successfully',ret=url,button='return to admin Dashboard')
    else:
        url=url_for('A_dashboard')
        return render_template('alert.html', msg= 'category already exist',ret=url,button='return to admin Dashboard')

@app.route('/del_cat/<id>', methods=['GET','POST'])
def delete_cat(id):
    prod=Category.query.filter_by(id=id).first()
    cat = db.session.query(Category).filter_by(id=id).first()
    products_to_delete = db.session.query(Product).filter_by(category=prod.category).all()
    for product in products_to_delete:
        db.session.delete(product)
    db.session.delete(cat)
    db.session.commit()
    db.session.close    
    url=url_for('A_dashboard')
    return render_template('alert.html', msg= 'category deleted Successfully',ret=url,button='return to admin Dashboard')
 
@app.route('/edit_category', methods=['GET','POST'])
def edit():
    cat = db.session.query(Category).filter_by(id=request.form.get('id')).first()
    prod=db.session.query(Product).filter_by(category=cat.category).all()
    if cat!=None:
        for prods in prod:
            prods.category=request.form.get('name')
        cat.category=request.form.get('name')
        cat.type=request.form.get('name')
        db.session.commit()
        db.session.close  
        url=url_for('A_dashboard')
        return render_template('alert.html', msg= 'category edited Successfully',ret=url,button='return to admin Dashboard')
    else:
        url=url_for('A_dashboard')
        return render_template('alert.html', msg= 'category does not exist',ret=url,button='return to admin Dashboard')
        
@app.route('/logout')
def logout():
    session.pop('user_id', None)
    session.pop('user',None)
    return redirect('/')

@app.route('/A_dashboard' ,methods=['GET','POST'])
def A_dashboard():
    try:
        product=Product.query.all()
        category=Category.query.all()
        
        return render_template('A_dashboard.html',category=category,product=product,user=session['user'])
    except:
        url=url_for('A_login')
        return render_template('alert.html', msg= 'Something went wrong',ret=url,button='return to login')

@app.route('/summary', methods=['GET','POST'])
def summary():
    #try:
        purchases = Purchase.query.all()
        des= os.path.abspath('Code')


        cat_counts = {}

        for product in purchases:
            category = product.category
            if category in cat_counts:
                cat_counts[category] += 1
            else:
                cat_counts[category] = 1
        plt.figure(figsize=(10, 6))
        plt.bar(cat_counts.keys(), cat_counts.values(), color='skyblue')
        plt.xlabel('Category')
        plt.ylabel('Number of Bought Products')
        plt.title('Number of Bought Products per Category')

        plt.savefig(des+'\static\\'+"1.png")  


        one_week_ago = date.today() - timedelta(days=7)

        purchases_within_week = (
            db.session.query(Purchase)
            .filter(Purchase.date_added >= one_week_ago)
            .all()
        )

        purchase_counts = {}
        for purchase in purchases_within_week:
            product_name =Product.query.filter_by(id=purchase.p_id).first()
            if product_name.name in purchase_counts:
                purchase_counts[product_name.name] += purchase.count
            else:
                purchase_counts[product_name.name] = purchase.count


        product_names = list(purchase_counts.keys())
        counts = list(purchase_counts.values())

        plt.figure(figsize=(12, 6))
        plt.bar(product_names, counts)
        plt.xlabel("Product")
        plt.ylabel("Number of Purchases")
        plt.title("Number of Purchases for Each Product in the Last Week")

        plt.savefig(des+'\static\\'+"2.png") 

        db.session.close
        return render_template('summary.html')
    #except:
        url=url_for('A_dashboard')
        return render_template('alert.html', msg= 'Something went wrong',ret=url,button='return to admin dashboard')