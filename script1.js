// Toggle between Sign In and Sign Up forms
document.getElementById("signInButton").addEventListener("click", function() {
    document.getElementById("signup").style.display = "none";
    document.getElementById("signIn").style.display = "block";
});

document.getElementById("signUpButton").addEventListener("click", function() {
    document.getElementById("signIn").style.display = "none";
    document.getElementById("signup").style.display = "block";
});

// View Expenses button functionality
function viewExpenses() {
    alert("Here you can implement a modal or a new page to view expenses.");
}

// Show/Hide Password functionality
document.querySelectorAll(".input-group input[type='password']").forEach(input => {
    const toggleButton = document.createElement('i');
    toggleButton.className = "fas fa-eye-slash toggle-password";
    input.parentNode.appendChild(toggleButton);

    toggleButton.addEventListener("click", () => {
        if (input.type === "password") {
            input.type = "text";
            toggleButton.className = "fas fa-eye toggle-password";
        } else {
            input.type = "password";
            toggleButton.className = "fas fa-eye-slash toggle-password";
        }
    });
});
