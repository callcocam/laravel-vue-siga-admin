<template>
    <div>
        Aguarde...
    </div>
</template>

<script>
    export default {
        name: "logout",
        created() {
            setTimeout(()=>{
                // if user is logged in via auth0
                auth.logOut();
                // This is just for demo Purpose. If user clicks on logout -> redirect
                this.$router.push({name:'admin.auth.login'}).catch(() => {})
            }, 1000)
        }
    }
</script>

<style scoped>

</style>
