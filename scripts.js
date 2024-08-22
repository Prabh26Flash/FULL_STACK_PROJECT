document.addEventListener("DOMContentLoaded", function() {
    const signUpButton = document.getElementById("signUpButton");
    const signInButton = document.getElementById("signInButton");
    const signUpContainer = document.getElementById("signup");
    const signInContainer = document.getElementById("signIn");

    if (signUpButton && signInButton && signUpContainer && signInContainer) {
        signUpButton.addEventListener("click", function() {
            signUpContainer.style.display = "block";
            signInContainer.style.display = "none";
        });

        signInButton.addEventListener("click", function() {
            signUpContainer.style.display = "none";
            signInContainer.style.display = "block";
        });
    }
});
