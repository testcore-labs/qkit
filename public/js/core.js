function sidebar() {
  var sidebar = document.getElementById('sidebar');
  sidebar.style.display = (sidebar.style.display === 'block') ? 'none' : 'block';
}

function getvids(elementId) {
  const element = document.getElementById(elementId);
  element.classList.remove("centerplz");
  fetch('/api/getvideos', {
  method: 'GET',
  headers: {
  'Content-Type': 'application/json'
  }
  })
  .then(response => response.json())
  .then(vids => {
  
  fetch('/api/videoshtml', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    },
    body: JSON.stringify({
    json: vids
    })
  })
    .then(response => response.text())
    .then(html => {
    element.innerHTML = html;
    })
    .catch(error => {
    element.innerHTML = "";
    element.classList.add("centerplz");
    var errmsg = document.createElement("span");
    errmsg.innerHTML = "something went wrong while styling videos:<br>"+error;
    element.appendChild(errmsg);
    });
  })
  .catch(error => {
  element.innerHTML = "";
  element.classList.add("centerplz");
  var errmsg = document.createElement("span");
  errmsg.innerHTML = "something went wrong while getting videos:<br>"+error;
  element.appendChild(errmsg);
  });
  }

function register(un, pw, cpw, err, hcap) {
  err.classList.add("d-none")
  err.innerHTML = "";
  fetch('/api/register', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      username: un,
      password: pw,
      cpassword: cpw,
      hcap: hcap,
    })
  })
  .then(response => response.json())
  .then(shit => {
    if (shit.error) {
      err.classList.toggle("d-none");
      err.innerHTML = shit.error.message;
    }
  })
    .catch(error => { 
      err.classList.toggle("d-none");
      err.innerHTML = error;
    });
}


function randdelay(min, max) {
return Math.floor(Math.random() * (max - min + 1) + min);
}

async function retype(element) {
const text = element.textContent;
element.textContent = '';

for (let i = 0; i < text.length; i++) { 
element.textContent += text.charAt(i);
await new Promise((resolve) => setTimeout(resolve, randdelay(15, 50)));
}
}

async function retypeforeach (elements, index) {
if (index < elements.length) {
const element = elements[index];
element.classList.remove('retype');
await retype(element);

index++;
await retypeforeach(elements, index);
}
}

retypeforeach(Array.from(document.getElementsByClassName('retype')), 0);