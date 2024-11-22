document.querySelector("form").addEventListener("submit", function (event) {
  let username = document.querySelector("[name='username']").value;
  let email = document.querySelector("[name='email']").value;
  let password = document.querySelector("[name='password']").value;
  let passwordConfirm = document.querySelector("[name='password_confirm']").value;

  if (username.length < 3) {
    alert("Username must be at least 3 characters long.");
    event.preventDefault();
    return;
  }

  if (password !== passwordConfirm) {
    alert("Passwords do not match.");
    event.preventDefault();
    return;
  }

  let emailPattern = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
  if (!emailPattern.test(email)) {
    alert("Please enter a valid email address.");
    event.preventDefault();
    return;
  }

  if (password.length < 6) {
    alert("Password must be at least 6 characters long.");
    event.preventDefault();
    return;
  }
});
