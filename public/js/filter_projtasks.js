document.addEventListener("DOMContentLoaded",function(){let e=document.getElementById("tasknameFilter"),t=document.getElementById("duedateFilter"),n=document.getElementById("taskstatusFilter"),a=document.getElementById("taskpriorityFilter"),s=document.getElementById("assignedFilter"),l=document.getElementById("filter");function d(){let d=e.value.toUpperCase(),i=t.value.toUpperCase(),p=n.value.toUpperCase(),r=a.value.toUpperCase(),o=s.value.toUpperCase(),u=l.getElementsByTagName("tr");for(let C=1;C<u.length;C++){let E=u[C],g=E.getElementsByTagName("td"),m=g[0].textContent.toUpperCase(),v=g[1].textContent.toUpperCase(),y=g[2].textContent.toUpperCase(),U=g[3].textContent.toUpperCase(),B=g[4].textContent.toUpperCase(),c=m.includes(d),L=v.includes(i),I=y.includes(p),x=U.includes(r),F=B.includes(o);E.style.display=c&&L&&I&&x&&F?"":"none"}}e.addEventListener("input",d),t.addEventListener("input",d),n.addEventListener("input",d),a.addEventListener("input",d),s.addEventListener("input",d)});