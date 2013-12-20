
function howMuchScroll()
{
return self.pageYOffset || (document.documentElement && document.documentElement.scrollTop) || (document.body && document.body.scrollTop);
}



addEventListener('scroll', autoloadjobs,false);


function autoloadjobs()
{

    if(howMuchScroll() + window.innerHeight >= document.documentElement.scrollHeight)
        {
            
        getnextjobs();
        }
}



function getXmlHttp()
{
    var xmlhttp;

    try
    {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }

    catch (e)
    {
        try
        {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (E)
        {
            xmlhttp = false;
        }
    }

    if(!xmlhttp && typeof XMLHttpRequest!='undefined')
    {
        xmlhttp = new XMLHttpRequest();
    }

    return xmlhttp;
}

function getnextjobs()
{
    
    var req = getXmlHttp();
    var url = 'index.php?require_page=load_jobs&skip=' + count_jobs + '&parser_id=' + parser_id;
    count_jobs +=5;

    req.open('GET', url, true);
    req.onreadystatechange = update;
    req.send(null);
    return true;

    function update()
    {
            if(req.readyState == 4)
            {
                    if(req.status == 200)
                    {
                        document.getElementById('list_jobs').innerHTML = document.getElementById('list_jobs').innerHTML + req.responseText;
                    }
            }
    }
}

//Event.add(elem, 'click', handler);