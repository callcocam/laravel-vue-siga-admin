<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $t('Login') }}</div>
                    <div class="card-body">
                        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
                            <div class="form-group">
                                <label>Username</label>
                                <input v-model="form.email" type="text" name="email"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="form.remember">

                                        <label class="form-check-label" for="remember">
                                            {{ $t('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button :disabled="form.busy" type="submit" class="btn btn-primary">Log In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Form } from 'vform'
    export default {
        layout:"auth",
        name: "login",
        data () {
            return {
                // Create a new form instance
                form: new Form({
                    email: 'admin@localhost.crm-02.test',
                    password: 'password',
                    remember: false
                })
            }
        },
        methods: {
            login () {
                // Submit the form via a POST request
                this.form.post('/api/v1/admin/login')
                    .then(({ data }) => {
                        this.$store.dispatch("userInfo", data);
                        // Navigate User to homepage
                        this.$router.push( this.$router.currentRoute.query.to || {name:'admin'})
                    }).catch(error=>{
                    console.log(error)
                })
            }
        }
    }
</script>

<style scoped>

</style>
