const BtnFilter = document.querySelector('#btnDateFilter')
const table = document.querySelector('.table')

BtnFilter.addEventListener('click' , () => {
    let InputStart = document.querySelector('#Start')
    let Start = InputStart.value

    let InputEnd = document.querySelector('#End')
    let End = InputEnd.value
    
    const dateCycle = document.querySelector('#dateCycle')

    const DateStartFr = new Date(Start)
    const DateEndFr = new Date(End)
    const optionsStart = { weekday: 'long', month: 'long', day: 'numeric' };
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    dateCycle.innerHTML = "Du " + DateStartFr.toLocaleDateString(undefined, optionsStart) + " au " +DateEndFr.toLocaleDateString(undefined, options)

    fetch("/api/transaction/date?Start="+Start+"&End="+End)
    .then(response => response.json())
    .then(data => data)
    .then(data => formatTableTransaction(data))
})

function formatTableTransaction(data)
{
    deleteDataTransaction()
    data.forEach(row => {
        let tr = insertDataRow(row)
        table.appendChild(tr)
    });
   
}

function insertSum(Sum)
{
    const td = document.createElement("td")
        td.setAttribute('class' , 'text-start')
        td.innerText = String(Sum)+"€"
    return td
}

function insertType(Type)
{
    const td = document.createElement("td")
    td.setAttribute('class' , "typeElement")
    const spanIcon = document.createElement("span")
    const spanText = document.createElement("span")
   
    spanIcon.setAttribute("class" , " text-light customFetchIcon")
    if(Type === 'Entrer')
    {
        spanIcon.setAttribute('style' , "background: green;")
        const span1 = document.createElement("span")
        const span2 = document.createElement("span")
        const span3 = document.createElement("span")
        spanIcon.appendChild(span1)
        spanIcon.appendChild(span2)
        spanIcon.appendChild(span3)
        td.innerText = " Entrer"
    }
    else
    {
        spanIcon.setAttribute('style' , "background: red ;")
        const span1 = document.createElement("span")
        const span2 = document.createElement("span")
        const span3 = document.createElement("span")
        spanIcon.appendChild(span1)
        spanIcon.appendChild(span2)
        spanIcon.appendChild(span3)
        td.innerText = " Sortie"
    }

    td.prepend(spanIcon)
 

    return td
}

function insertLibelle(libelle)
{
    const td = document.createElement("td")
    td.innerHTML = String(libelle)
    return td
}

function insertCat(Category)
{
    const td = document.createElement("td")
        td.setAttribute('class' , "badge")
        td.setAttribute('style' , "background:"+Category.Color)
    td.innerHTML = String(Category.Label)
    return td
}

function insertWay(Way)
{
    const td = document.createElement("td")
    td.innerHTML = String(Way)
    return td
}
function insertDate(Date)
{
    const td = document.createElement("td")
    const dateFormat = String(Date.replace('T00:00:00+00:00',''));
    const tabDataDate = dateFormat.split("-")
    td.innerHTML = tabDataDate[2]+"-"+tabDataDate[1]+"-"+tabDataDate[0].slice(-2)
    return td
}

function insertActions(objet)
{
    const td = document.createElement("td")
    const aEdit = document.createElement("a")
    const aDelete = document.createElement("a")
    const spanEdit = document.createElement("span")
    const spanDelete = document.createElement("span")
    aEdit.setAttribute("href" , "/transaction/edit/"+objet.id)
    aDelete.setAttribute("href" , "/transaction/delete/"+objet.id)
    spanEdit.setAttribute('class', "material-icons bg-secondary p-1 text-light rounded")
    spanDelete.setAttribute('class', "material-icons bg-warning p-1 text-light rounded")
    
    spanEdit.innerText = "edit"
    spanDelete.innerText = "delete"
    aEdit.appendChild(spanEdit)
    aDelete.appendChild(spanDelete)
    td.appendChild(aEdit)
    td.appendChild(aDelete)
    
    return td
}

function deleteDataTransaction()
{
    let tableData = document.querySelectorAll('.rowData')
    tableData.forEach(rowData => {
        rowData.remove()
    });
}


function insertDataRow(objet)
{
    const tr = document.createElement("tr")
        tr.setAttribute("class" , "rowData rowTable")
     let type =  insertType(objet.TypeTransaction.label)
     let Sum =  insertSum(objet.sum)
     let libelle = insertLibelle(objet.libelle)
     let cat = insertCat(objet.Category)
     let Way = insertWay(objet.WayTransaction.Label)
     let Date = insertDate(objet.dateTransaction)
     let Actions = insertActions(objet)
    tr.appendChild(type)
    tr.appendChild(Sum)
    tr.appendChild(libelle)
    tr.appendChild(cat)
    tr.appendChild(Way)
    tr.appendChild(Date)
    tr.appendChild(Actions)
    return tr
}

