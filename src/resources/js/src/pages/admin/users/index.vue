<script>
    // @ is an alias to /src
    import AbstractList from "@views/admin/AbstractList";
    export default {
        name: 'admin',
        extends:AbstractList,
        mounted() {
            this.page = "Users"
        }
    }
</script>
