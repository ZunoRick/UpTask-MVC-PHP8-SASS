!function(){const e=window.location.origin;!async function(){try{const n=o(),r=`${e}/api/tareas?id=${n}`,c=await fetch(r),d=await c.json();t=d.tareas,a()}catch(e){console.log(e)}}();let t=[];function a(){if(function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),0===t.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("LI");return t.textContent="No Hay Tareas",t.classList.add("no-tareas"),void e.appendChild(t)}const r={0:"Pendiente",1:"Completa"};t.forEach(c=>{const{id:d,estado:s,nombre:i}=c,l=document.createElement("LI");l.dataset.tareaId=d,l.classList.add("tarea");const u=document.createElement("P");u.textContent=i;const m=document.createElement("DIV");m.classList.add("opciones");const p=document.createElement("BUTTON");p.classList.add("estado-tarea"),p.classList.add(""+r[s].toLowerCase()),p.textContent=r[s],p.dataset.estadoTarea=s,p.onclick=function(){!function(r){const c="1"===r.estado?"0":"1";r.estado=c,async function({estado:r,id:c,nombre:d}){const s=new FormData;s.append("id",c),s.append("nombre",d),s.append("estado",r),s.append("proyectoId",o());try{const o=e+"/api/tarea/actualizar",d=await fetch(o,{method:"POST",body:s}),i=await d.json();"exito"===i.tipo&&(n(i.mensaje,i.tipo,document.querySelector(".contenedor-nueva-tarea")),t=t.map(e=>(e.id===c&&(e.estado=r),e)),a())}catch(e){console.log(e)}}(r)}({...c})};const f=document.createElement("BUTTON");f.classList.add("eliminar-tarea"),f.dataset.idTarea=d,f.textContent="Eliminar",m.appendChild(p),m.appendChild(f),l.appendChild(u),l.appendChild(m);document.querySelector("#listado-tareas").appendChild(l)})}function n(e,t,a){const n=document.querySelector(".alerta");n&&n.remove();const o=document.createElement("DIV");o.classList.add("alerta",t),o.textContent=e,a.parentElement.insertBefore(o,a.nextElementSibling),setTimeout(()=>{o.remove()},5e3)}function o(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}document.querySelector("#agregar-tarea").addEventListener("click",(function(){const r=document.createElement("DIV");r.classList.add("modal"),r.innerHTML='\n      <form class="formulario nueva-tarea">\n        <legend>Añade una nueva tarea</legend>\n        <div class="campo">\n          <label>Tarea</label>\n          <input\n            type="text"\n            name="tarea"\n            placeholder="Añadir tarea al Proyecto Actual"\n            id="tarea"\n          />\n        </div>\n        <div class="opciones">\n          <input \n            type="submit" \n            class="submit-nueva-tarea"\n            value="Añadir Tarea"\n          />\n          <button class="cerrar-modal">Cancelar</button>\n        </div>\n      </form>\n    ',setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),r.addEventListener("click",(function(c){if(c.preventDefault(),c.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{r.remove()},500)}c.target.classList.contains("submit-nueva-tarea")&&function(){const r=document.querySelector("#tarea").value.trim();if(""===r)return void n("El nombre de la tarea es obligatorio","error",document.querySelector(".formulario legend"));!async function(r){const c=new FormData;c.append("nombre",r),c.append("proyectoId",o());try{const o=e+"/api/tarea",d=await fetch(o,{method:"POST",body:c}),s=await d.json();if(n(s.mensaje,s.tipo,document.querySelector(".formulario legend")),"exito"===s.tipo){const e=document.querySelector(".modal");setTimeout(()=>{e.remove()},2e3);const n={id:String(s.id),nombre:r,estado:0,proyectoId:s.proyectoId};t=[...t,n],a()}}catch(e){console.log(e)}}(r)}()})),document.querySelector(".dashboard").appendChild(r)}))}();