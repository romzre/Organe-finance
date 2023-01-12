
function insertType(Type)
{
    const td = document.createElement("td")
    const spanIcon = document.createElement("span")
    const spanText = document.createElement("span")
    spanText.innerHTML = "Type"

    spanIcon.setAttribute("class" , " material-icons text-light")
    if(Type === 'Entrer')
    {
        spanIcon.setAttribute('style' , "background: green")
        spanIcon.innerHTML = "arrow_forward"
        spanText.innerHTML = "Type"
    }
    else
    {
        spanIcon.setAttribute('style' , "background: red")
        spanText.innerHTML = "arrow_backward"
       
    }

    td.appendChild(spanIcon)
    td.appendChild(spanText)

    return td
}

export { insertType };