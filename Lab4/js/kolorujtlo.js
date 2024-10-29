var time = 0;
function changeBackground(hexNumber,hexNumber2)
{
    if(time==0)
        {
            document.body.style.background = hexNumber;
            time=1;
        }
    else
        {
            document.body.style.background = hexNumber2;
            time=0;
        }
    
}