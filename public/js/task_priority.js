document.addEventListener("DOMContentLoaded",function(){for(var e=document.getElementById("priority_filter"),t=document.getElementById("filteredTasks"),n={},a=t.getElementsByTagName("li"),l=0;l<a.length;l++)n[l]=a[l].style.display||"block";e.addEventListener("change",function(){!function e(a){for(var l=t.getElementsByTagName("li"),i=!1,r=0;r<l.length;r++){var o=l[r].getAttribute("data-priority");""===a||o.toLowerCase()===a.toLowerCase()||"All"===a?(l[r].style.display=n[r],i=!0):l[r].style.display="none"}}(e.value)}),e.dispatchEvent(new Event("change"))});