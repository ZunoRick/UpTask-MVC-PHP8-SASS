!function(){const e=window.location.origin;!async function(){try{const a=d(),n=`${e}/api/tareas?id=${a}`,r=await fetch(n),c=await r.json();t=c.tareas,o()}catch(e){console.log(e)}}();let t=[],a=[];document.querySelector("#agregar-tarea").addEventListener("click",(function(){c()}));function n(e){const n=e.target.value;a=""!==n?t.filter(e=>e.estado===n):[],o()}function o(){!function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),function(){const e=t.filter(e=>"0"===e.estado),a=document.querySelector("#pendientes");0===e.length?a.disabled=!0:a.disabled=!1}(),function(){const e=t.filter(e=>"1"===e.estado),a=document.querySelector("#completadas");0===e.length?a.disabled=!0:a.disabled=!1}();const n=a.length?a:t;if(0===n.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("LI");return t.textContent="No Hay Tareas",t.classList.add("no-tareas"),void e.appendChild(t)}const i={0:"Pendiente",1:"Completa"};n.forEach(a=>{const{id:n,estado:s,nombre:l}=a,u=document.createElement("LI");u.dataset.tareaId=n,u.classList.add("tarea");const m=document.createElement("P");m.textContent=l,m.onclick=function(){c(!0,{...a})};const p=document.createElement("DIV");p.classList.add("opciones");const f=document.createElement("BUTTON");f.classList.add("estado-tarea"),f.classList.add(""+i[s].toLowerCase()),f.textContent=i[s],f.dataset.estadoTarea=s,f.onclick=function(){!function(e){const t="1"===e.estado?"0":"1";e.estado=t,r(e)}({...a})};const y=document.createElement("BUTTON");y.classList.add("eliminar-tarea"),y.dataset.idTarea=n,y.textContent="Eliminar",y.onclick=function(){!function(a){Swal.fire({title:"¿Eliminar tarea?",text:"Una tarea eliminada no se puede recuperar",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Sí, eliminar"}).then(n=>{n.isConfirmed&&async function({estado:a,id:n,nombre:r}){const c=new FormData;c.append("id",n),c.append("nombre",r),c.append("estado",a),c.append("proyectoId",d());try{const a=e+"/api/tarea/eliminar",r=await fetch(a,{method:"POST",body:c}),i=await r.json();if(i)return t=t.filter(e=>e.id!==n),o(),i.mensaje}catch(e){console.log(e)}}(a).then(e=>Swal.fire("Eliminado",e,"success"))})}({...a})},p.appendChild(f),p.appendChild(y),u.appendChild(m),u.appendChild(p);document.querySelector("#listado-tareas").appendChild(u)})}async function r({estado:a,id:n,nombre:r}){const c=new FormData;c.append("id",n),c.append("nombre",r),c.append("estado",a),c.append("proyectoId",d());try{const i=e+"/api/tarea/actualizar",d=await fetch(i,{method:"POST",body:c}),s=await d.json();if("exito"===s.tipo){Swal.fire(s.mensaje,"","success");const e=document.querySelector(".modal");e&&e.remove(),t=t.map(e=>(e.id===n&&(e.estado=a,e.nombre=r),e)),o()}}catch(e){console.log(e)}}function c(a=!1,n={}){const c=document.createElement("DIV");c.classList.add("modal"),c.innerHTML=`\n      <form class="formulario nueva-tarea">\n        <legend>${a?"Editar Tarea":"Añade una nueva tarea"}</legend>\n        <div class="campo">\n          <label>Tarea</label>\n          <input\n            type="text"\n            name="tarea"\n            placeholder="${n.nombre?"Edita la Tarea":"Añadir tarea al Proyecto Actual"}"\n            id="tarea"\n            value="${n.nombre?n.nombre:""}"\n          />\n        </div>\n        <div class="opciones">\n          <input \n            type="submit" \n            class="submit-nueva-tarea"\n            value="${n.nombre?"Guardar Cambios":"Añadir Tarea"}"\n          />\n          <button class="cerrar-modal">Cancelar</button>\n        </div>\n      </form>\n    `,setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),c.addEventListener("click",(function(s){if(s.preventDefault(),s.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{c.remove()},500)}if(s.target.classList.contains("submit-nueva-tarea")){const c=document.querySelector("#tarea").value.trim();if(""===c)return void i("El nombre de la tarea es obligatorio","error",document.querySelector(".formulario legend"));a?(n.nombre=c,r(n)):async function(a){const n=new FormData;n.append("nombre",a),n.append("proyectoId",d());try{const r=e+"/api/tarea",c=await fetch(r,{method:"POST",body:n}),d=await c.json();if(i(d.mensaje,d.tipo,document.querySelector(".formulario legend")),"exito"===d.tipo){const e=document.querySelector(".modal");setTimeout(()=>{e.remove()},2e3);const n={id:String(d.id),nombre:a,estado:0,proyectoId:d.proyectoId};t=[...t,n],o()}}catch(e){console.log(e)}}(c)}})),document.querySelector(".dashboard").appendChild(c)}function i(e,t,a){const n=document.querySelector(".alerta");n&&n.remove();const o=document.createElement("DIV");o.classList.add("alerta",t),o.textContent=e,a.parentElement.insertBefore(o,a.nextElementSibling),setTimeout(()=>{o.remove()},5e3)}function d(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}document.querySelectorAll('#filtros input[type="radio"]').forEach(e=>{e.addEventListener("input",n)})}();