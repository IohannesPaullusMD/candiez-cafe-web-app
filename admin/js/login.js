function temp(e) {
  const username = document.querySelector("#email");
  const password = document.querySelector("#password");
  setAdminUserStatus(true, username.value, password.value, () => {
    console.log("Login successful");
  });
  e.preventDefault();
}

function viewLogin() {
  const root = document.querySelector("#root");
  const login = document.createElement("div");

  root.className = `
    container 
    d-flex 
    justify-content-center 
    align-items-center 
    vh-100
  `;
  root.innerHTML = "";
  root.appendChild(login);
  login.className = "card p-4 shadow";
  login.style.width = "350px";
  login.innerHTML = `
        <h3 class="text-center">Login</h3>
        <form id="login-form" method="get" onsubmit="temp(event)">
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input
              type="email"
              class="form-control"
              id="email"
              placeholder="Enter email"
            />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              placeholder="Enter password"
            />
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    `;
}
viewLogin();
