# Example list
L=[0,1,6,4,452,3445,22,14,1]

#Selection Sort
def Selection(L):
    n=len(L)
    for i in range(n-1):
        min=L[i]
        for j in range(i,n):
            if L[j]<min:
                min=L[j]
                (L[i],L[j])=(min,L[i])
    return L
print("SelectionSort :",Selection(L))

#Insertion Sort
def Insertion(L):
    n=len(L)
    for i in range(n):
        j=i
        while(j>0 and L[j]<L[j-1]):
            L[j-1],L[j]=L[j],L[j-1]
            j=j-1
    return L
print("InsertionSort :",Insertion(L))

#Merge Sort
def MergeSort(L):
    n=len(L)
    
    if n<=1:
        return L
    Left=MergeSort(L[n//2:])
    Right=MergeSort(L[:n//2])

    res=Merge(Left,Right)
    return res

#merge of list
def Merge(Left,Right):
    m,n=len(Left),len(Right)
    (merge,Left_index,Right_index,merge_index)=([],0,0,0)

    while merge_index<m+n:
        if Left_index==m:
            merge.extend(Right[Right_index:])
            merge_index=merge_index+n-Right_index
            
        elif Right_index==n:
            merge.extend(Left[Left_index:])
            merge_index=merge_index+m-Left_index
            
        elif Left[Left_index]<Right[Right_index]:
            merge.append(Left[Left_index])
            Left_index,merge_index=Left_index+1,merge_index+1

        else:
            merge.append(Right[Right_index])
            Right_index,merge_index=Right_index+1,merge_index+1
    
    return merge
print("MergeSort :",MergeSort([0,1,6,4,452,3445,22,14,1]))

# Quick sort
def QuickSort(L,lower_index,upper_index):
    if upper_index-lower_index<=1:
        return L
    (pivot,lower,upper)=(L[lower_index],lower_index+1,lower_index+1)
    for i in range(lower_index+1,upper_index):
        if L[i]>pivot:
            upper=upper+1
        else:
            #partitionong
            (L[i],L[lower])=(L[lower],L[i])
            (lower,upper)=(lower+1,upper+1)
    (L[lower_index],L[lower-1])=(L[lower-1],L[lower_index])
    lower=lower-1
    QuickSort(L,lower_index,lower)
    QuickSort(L,lower+1,upper)
    return L
print("QuickSort :",QuickSort(L,0,len(L)))