let btnPrimary = document.querySelector('#primary');

btnPrimary.addEventListener('click', () => btnPrimary.style.backgroundColor='#556B2F',)

function change()
{
    document.getElementById("connect-button").value="Connected"; 
}
// https://stackoverflow.com/questions/42272893/change-button-on-clicked-and-records-update-in-database-and-vice-versa
// Change button name if users are connected 