document.addEventListener("DOMContentLoaded",function(){let e=document.getElementById("nameFilter"),t=document.getElementById("dateFilter"),n=document.getElementById("companyFilter"),a=document.getElementById("coordinatorFilter"),l=document.getElementById("filter");function d(){let d=e.value.toUpperCase(),i=t.value.toUpperCase(),o=n.value.toUpperCase(),p=a.value.toUpperCase(),r=l.getElementsByTagName("tr");for(let s=1;s<r.length;s++){let u=r[s],C=u.getElementsByTagName("td"),E=C[0].textContent.toUpperCase(),m=C[1].textContent.toUpperCase(),g=C[2].textContent.toUpperCase(),y=C[3].textContent.toUpperCase(),v=E.includes(d),c=m.includes(i),U=g.includes(o),B=y.includes(p);u.style.display=v&&c&&U&&B?"":"none"}}e.addEventListener("input",d),t.addEventListener("input",d),n.addEventListener("input",d),a.addEventListener("input",d)});