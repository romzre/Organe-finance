

const BtnFilter = document.querySelector('#btnDateFilter')


BtnFilter.addEventListener('click' , () => {
    let InputStart = document.querySelector('#Start')
    let Start = InputStart.value

    let InputEnd = document.querySelector('#End')
    let End = InputEnd.value

    fetch("/api/transaction/date?Start="+Start+"&End="+End)
    .then(response => response.json())
    .then(data => data[0])
    .then(data => formatTableTransaction(data))
})


function formatTableTransaction(data)
{
    console.table(data)
}