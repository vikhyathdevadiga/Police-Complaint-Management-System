function showLoginPassword(x, y)
{
var pwd = document.getElementById(y);
var hide = document.getElementById(x);
if (hide.className == 'fa fa-eye')
{
hide.className = 'fa fa-eye-slash';
}
else
{
hide.className = 'fa fa-eye';
}
if (pwd.type === "password")
{
pwd.type = "text";
}
else
{
pwd.type = "password";
}
}