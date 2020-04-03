<template>
    <div>
        {{userData}}
    </div>
</template>

<script>
    export default {
        name: "profile",
        computed:{

            userData(){
                return this.$store.getters.userInfo
            }
        }
    }
</script>

<style scoped>

</style>
