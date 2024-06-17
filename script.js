const form = document.querySelector("form");
const fullName = document.getElementById("name");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const subject = document.getElementById("subject");
const mess = document.getElementById("message");

function sendEmail() {
    const Messages = `Full Name: ${fullName.value}<br> Email: ${email.value}<br> Phone Number: ${phone.value}<br> Message: ${mess.value}`;

    Email.send({
        Host: "smtp.elasticemail.com",
        Username: "employhub96@gmail.com",
        Password: "7A176E3D7742320F9A3C7A342223AFBDD621",
        To: 'employhub96@gmail.com',
        From: "employhub96@gmail.com",
        Subject: subject.value,
        Body: Messages
    }).then(
        message => {
            if (message === "OK") {
                Swal.fire({
                    title: "SUCCESS!",
                    text: "Messsage sent successfully!",
                    icon: "success"
                });

                // Reset the form
                form.reset();
            }
        }
    );
}

form.addEventListener("submit", (e) => {
    e.preventDefault();

    sendEmail();
});
