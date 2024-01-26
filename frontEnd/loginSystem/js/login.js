const emailerror = document.getElementById('emailerror');
const passerror = document.getElementById('passerror');


function SubmitForm(){

    const email = document.getElementById('your_name').value;
    const pass = document.getElementById('your_pass').value;

    const dataToSend = {
        email,
        pass
    }

    fetch("./backend/login.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(dataToSend),
      })
        .then((response) => response.text())
        .then((data) => {
          console.log(data);
          if(data === "inValidEmail"){
            emailerror.classList.remove('d-none');
            passerror.classList.add('d-none');
            
        }else if( data === "iscorrectPassword"){
            passerror.classList.remove('d-none');
            emailerror.classList.add('d-none');
            
          }else if( data === "loginSuccess"){
            window.location.href = "../index.php";
          }

        })
        .catch((error) => {
          console.error("Error:", error);
        });
}