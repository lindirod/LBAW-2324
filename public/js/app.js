let csrf=document.querySelector('input[name="_token"]');const csrfToken=csrf?csrf.value:"";function encodeForAjax(e){return null==e?null:Object.keys(e).map(function(t){return encodeURIComponent(t)+"="+encodeURIComponent(e[t])}).join("&")}function sendAjaxRequest(e,t,n,s){let o=new XMLHttpRequest;o.open(e,t,!0),o.setRequestHeader("X-CSRF-TOKEN",document.querySelector('meta[name="csrf-token"]').content),o.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),o.addEventListener("load",s),o.send(encodeForAjax(n))}function genericResponseHandlerWithRefresh(){207==this.status&&alert(this.response),location.reload(!0)}function genericResponseHandler(){console.log(this.status),this.status>=400?location.reload(!0):207==this.status&&alert(this.response)}function setUpAddToFavorites(){let e=document.querySelector(".project-overview").getAttribute("data-id"),t=document.querySelector("#add-fav-butt");"project-fav-button fa fa-heart"==t.className?(sendAjaxRequest("post","/projects/"+e+"/removeFavorite"),t.className="project-fav-button fa fa-heart-o"):(sendAjaxRequest("post","/projects/"+e+"/addFavorite"),t.className="project-fav-button fa fa-heart")}function setUpArchive(){let e=document.querySelector(".project-overview").getAttribute("data-id"),t=document.querySelector("#add-arch-butt");"project-arch-button fa fa-folder"==t.className?(sendAjaxRequest("post","/projects/"+e+"/unarchive"),t.className="project-arch-button fa fa-folder-open"):(sendAjaxRequest("post","/projects/"+e+"/archive"),t.className="project-arch-button fa fa-folder")}function removeMembers(){var e=document.getElementById("remove_members"),t=new FormData(e);fetch(e.action,{method:"POST",body:t,headers:{"X-CSRF-TOKEN":t.get("_token")}}).then(e=>{if(!e.ok)throw Error("Network response was not ok");return e.text()}).then(e=>{console.log("Members removed successfully:",e),document.getElementById("removeMembers-status").innerText="Members removed successfully"}).catch(e=>{console.error("There was a problem with the fetch operation:",e),document.getElementById("removeMembers-status").innerText="Error removing members"})}function editProject(e,t,n,s){sendAjaxRequest("put","/api/projects/"+e+"/edit",{name:t,due_date:n,description:s},function(){if(200===this.status){let e=JSON.parse(this.responseText);console.log("Project updated:",e)}else console.error("Error updating project:",this.status,this.responseText);location.reload(!0)})}function editTask(e,t,n,s,o){sendAjaxRequest("put","/tasks/"+e+"/edit",{name:t,due_date:n,new_member:s,status:o},function(){if(200===this.status){let e=JSON.parse(this.responseText);console.log("Task updated:",e)}else console.error("Error updating task:",this.status,this.responseText);location.reload(!0)})}function toggleAnswer(e){var t=document.getElementById(e+"-answer");"none"===t.style.display||""===t.style.display?t.style.display="block":t.style.display="none"}document.addEventListener("DOMContentLoaded",function(){let e=document.getElementById("editProjSection"),t=e.getAttribute("data-id"),n=document.getElementById("editProjectButton"),s=document.getElementById("openUpdateFormButton");s.addEventListener("click",function(){console.log("Button clicked!"),e.classList.toggle("hidden"),document.getElementById("update-form").style.display="grid",document.getElementById("opaque-proj").style.display="flex",document.getElementById("project-background").style.display="none"}),document.getElementById("close-update-form").addEventListener("click",function(){document.getElementById("update-form").style.display="none",document.getElementById("opaque-proj").style.display="none",document.getElementById("project-background").style.display="grid"}),n.addEventListener("click",function(){e.classList.toggle("hidden");let n=document.getElementById("update-project-name").value,s=document.getElementById("update-project-date-input").value,o=document.getElementById("update-project-description-input").value;editProject(t,n,s,o)})}),document.addEventListener("DOMContentLoaded",function(){let e=document.getElementById("editTaskSection"),t=e.getAttribute("data-id"),n=document.getElementById("editTaskButton"),s=document.getElementById("openEditFormButton");s.addEventListener("click",function(){console.log("Button clicked!"),e.classList.toggle("hidden"),document.getElementById("edit-form").style.display="grid",document.getElementById("opaque").style.display="flex",document.getElementById("task-background").style.display="none"}),document.getElementById("close-edit-form").addEventListener("click",function(){document.getElementById("edit-form").style.display="none",document.getElementById("opaque").style.display="none",document.getElementById("task-background").style.display="grid"}),n.addEventListener("click",function(){e.classList.toggle("hidden");let n=document.getElementById("edit-task-name").value,s=document.getElementById("edit-task-date-input").value,o=document.querySelector('select[name="new_member"]').value,r=document.querySelector('select[name="status"]').value;editTask(t,n,s,o,r)})}),document.addEventListener("DOMContentLoaded",function(){document.getElementById("add-task-comment-button").addEventListener("click",function(){let e=document.getElementById("add-task-page-comment"),t=document.getElementById("add-task-comment-content-input").value,n=e.getAttribute("data-id");""!==t.trim()&&sendAjaxRequest("PUT","/api/tasks/"+n+"/comment",{content:t},function(){if(200===this.status){let e=JSON.parse(this.responseText).comment,t=document.createElement("div");t.className="comment_header",t.innerHTM,L=`
                      <h4 class="title">${e.author.name}</h4>
                      <p>${e.content}</p>
                  `;let n=document.createElement("div");n.className="comment_footer",n.innerHTML=`<p>${e.date}</p>`;let s=document.getElementById("task-comments-container");s.insertBefore(t,s.firstChild),s.insertBefore(n,s.firstChild),document.getElementById("add-task-comment-content-input").value=""}else console.error("Error adding comment");location.reload(!0)})})});var faqQuestions=document.querySelectorAll(".faq-page");faqQuestions.forEach(function(e){e.addEventListener("click",function(){toggleAnswer(e.id)})});var loadFile=function(e){var t=document.getElementById("tempProfilePhoto");t.src=URL.createObjectURL(e.target.files[0]),t.onload=function(){URL.revokeObjectURL(t.src)}};function setUpDeletePhoto(){document.querySelector("#deleteImageButtonID").addEventListener("click",function(e){e.preventDefault(),confirm("Are you sure you want to delete your current profile picture?")&&sendAjaxRequest("get","api/user/deleteUserPhoto",null,genericResponseHandlerWithRefresh)})}function setUpProfileImagesLinks(){document.querySelectorAll(".profile-image-link").forEach(e=>{e.addEventListener("click",function(){let t=e.getAttribute("data-id");location.href="/projects/profile/"+t})})}setUpDeletePhoto(),setUpAddToFavorites(),removeMembers(),setUpArchive(),setUpProfileImagesLinks();