from sqlalchemy.ext.declarative import declarative_base
from flask_sqlalchemy import SQLAlchemy
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy import create_engine,or_,String
from sqlalchemy.sql.expression import cast
from datetime import date

engine = create_engine("sqlite:///db.sqlite3")
Base = declarative_base()
db = SQLAlchemy()





class User(db.Model):
    __tablename__ = 'user'
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    name = db.Column(db.String, unique=True, nullable=False)
    password = db.Column(db.String, nullable=False)
    telnum = db.Column(db.Integer, nullable=False)
    mail = db.Column(db.String, nullable=False)
    dob = db.Column(db.String, nullable=False)
    gender = db.Column(db.String, nullable=False)
    admin = db.Column(db.Boolean, nullable=False, default=False)

class Product(db.Model):
    __tablename__ = "product"
    id=db.Column(db.Integer,nullable=False,primary_key=True,autoincrement=True)
    dom=db.Column(db.String,nullable=False) 
    name = db.Column(db.String, unique=True, nullable=False)
    stock = db.Column(db.Integer, nullable=False)
    price = db.Column(db.Integer, nullable=False)
    category = db.Column(db.String,unique=True, nullable=False)
    units=db.Column(db.String, nullable=False)

class Category(db.Model):
    __tablename__ = "category"
    id=db.Column(db.Integer,primary_key=True,autoincrement=True)
    doa=db.Column(db.Date,nullable=False, default=date.today)
    type=db.Column(db.String,nullable=True)
    category = db.Column(db.String, nullable=False )

class Cart(db.Model):
    __tablename__ = "cart"
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    products = db.Column(db.Integer, nullable=False)
    count = db.Column(db.Integer, nullable=False,default=0)
    price = db.Column(db.Integer, nullable=False)
    date_added = db.Column(db.Date, nullable=False, default=date.today)

class Purchase(db.Model):
    __tablename__ = "purchase"
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    p_id = db.Column(db.Integer, nullable=False)
    count = db.Column(db.Integer, nullable=False,default=0)
    price = db.Column(db.Integer, nullable=False)
    date_added = db.Column(db.Date, nullable=False, default=date.today)
    user_id=db.Column(db.Integer, nullable=False,)
    category=db.Column(db.String,nullable=False)