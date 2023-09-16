function delegate(parent, type, selector, handler)
{
  parent.addEventListener(type, function (event)
  {
    const targetElement = event.target.closest(selector);

    if (this.contains(targetElement))
    {
      handler.call(targetElement, event);
    }
  });
}

function openClick(event)
{
	let attrs = event.target.getAttribute("style").split(" ");
	let img = attrs[attrs.length-1];
	img = img.substring(4, img.length-1);
	window.open(img);
}

function galleryClick(event)
{
  if (event.target.classList.contains("gallery"))
  {
    var index = Number(event.target.getAttribute("data-index"))-1;
    var children = event.target.querySelectorAll('div');
    var indexN = (index+1 == children.length ? 0 : index+1);
    children[indexN].classList.remove("hide");
    children[index].classList.add("hide");
    event.target.style.gridRowEnd = children[indexN].style.gridRowEnd;
    event.target.setAttribute("data-index", indexN+1);
  }
  else
  { openClick(event); }
}

function changeClick(event) {
  let attrs = this.getAttribute("data-dir");
  console.log(attrs);
  let img = attrs[attrs.length-1];
  img = img.substring(4, img.length-1);
  //window.open(img);
}

function setActiveStyleSheet(title) {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++)
  {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title"))
    {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
}

function today(show)
{
  let x = document.querySelectorAll('[data-today="true"]');
  if(show && x.length > 0)
  {
  let s = document.createElement('section');
  let h2 = document.createElement('h2');
  h2.innerHTML = "Today";
  h2.style.fontStyle = "italic";
  let r = document.querySelector("h2");
  let p = r.parentNode;
  p.insertBefore(s,r);
  p.insertBefore(h2,s);

  for (var i = 0; i < x.length; i++)
  {
    if(x[i].className != "image" && x[i].parentElement.className == "gallery")
    {
      s.appendChild(x[i].parentElement);
    }
    else
    {
      s.appendChild(x[i]);
    }
  }
  }
}
//delegate(document.querySelector("nav"), "click", "ul li", changeClick );