const iconHeadTables = document.querySelectorAll('.icon')
const headTables = document.querySelectorAll('.headTable')
const filterHeadTable = document.querySelector('#FHeadTable')

function disabledFilter()
{
    headTables.forEach(headTable => {
        headTable.classList.remove('text-success')
    })
    iconHeadTables.forEach(iconHeadTable => {
        iconHeadTable.classList.add('d-none')
    })
}

filterHeadTable.addEventListener('change' , (filterValue) => {
    disabledFilter()
    if(filterValue.target.value != "noValue" )
    {
        iconHeadTables[filterValue.target.value].classList.remove('d-none')
        headTables[filterValue.target.value].classList.add('text-success')

        // getDataFilter()
        // formatData()
    }
})