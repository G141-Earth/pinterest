function delegate(parent, type, selector, handler) {
  parent.addEventListener(type, function (event) {
    const targetElement = event.target.closest(selector);

    if (this.contains(targetElement)) {
      handler.call(targetElement, event);
    }
  });
}

function openClick(event) {
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

var mains = document.querySelectorAll("main");
for (var i = 0; i < mains.length; i++)
{
  delegate(mains[i], "click", "div.image", openClick );
  delegate(mains[i], "click", "div.gallery", galleryClick );
}
//delegate(document.querySelector("nav"), "click", "ul li", changeClick );