<template>
    <div class="container">
        <div class="p-3 parent-unauth">
            <img class="unauth" src="/Images/unauth.png" />
            <p class="text">You do not have the required permissions to access this page.</p>
            <router-link to="/" class='import2 add-cc hover-cc'>Back To Login</router-link>
        </div>
    </div>
</template>



<style scoped>
.parent-unauth{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.unauth{
    mix-blend-mode: darken;
    width: 40vw;
}
</style>
