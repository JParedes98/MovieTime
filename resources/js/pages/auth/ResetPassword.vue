<template>
<div>
    <navbar></navbar>

    <div class="container pt-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12 card card-body shadow">
                <form @submit.prevent="ResetPassword">
                    <div class="form-group">
                        <img src="/logo.png" style="max-width: 120px;" class="d-block m-auto" alt="">
                        <h2 class="font-weight-bold text-center text-muted my-4">¡RESET PASSWORD!</h2>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted" for="password"><i class="fas fa-unlock-alt"></i>&nbsp;NEW Password</label>
                        <input type="password" v-model="password" :class="{ 'is-invalid': validation.hasError('password')}" class="form-control" id="password" placeholder="Type your new password">
                        <div class="text-danger font-weight-bold">{{ validation.firstError('password') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted" for="repeat"><i class="fas fa-unlock-alt"></i>&nbsp;Confirm Password</label>
                        <input type="password" v-model="repeat" :class="{ 'is-invalid': validation.hasError('repeat')}" class="form-control" id="repeat" placeholder="Confirm your password">
                        <div class="text-danger font-weight-bold">{{ validation.firstError('repeat') }}</div>
                    </div>

                    <div class="form-group my-4">
                        <input type="submit" class="btn btn-block btn-primary" value="RESET PASSWORD">
                    </div>

                    <div class="form-group my-4">
                        <router-link to="/login" tag="button" class="btn btn-block btn-secondary">
                            GO BACK
                        </router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import SimpleVueValidation from 'simple-vue-validator';
const Validator = SimpleVueValidation.Validator;
Vue.use(SimpleVueValidation);

export default {
    data: function () {
        return {
            password: '',
            repeat: '',
        };
    },

    validators: {
        'password': function (value) {
            return Validator.value(value)
                .required('The password field is required.')
                .minLength(8, 'The password must be at least length.');
        },

        'repeat, password': function (repeat, password) {
            return Validator.value(repeat)
                .required('Plase confirm your password.')
                .match(password, 'Password confirmation do not match.');
        }
    },

    methods: {
        async ResetPassword() {
            var validation = await this.$validate();

            if(validation) {
                var formData = new FormData();
                formData.append('password', this.password);
                formData.append('password_confirmation', this.repeat);

                var token = this.$route.params.token;

                const config = {
                    headers: { Authorization: `Bearer ${token}` }
                };

                axios.post('/api/v1/auth/reset-password', formData, config)
                    .then((res) => {
                        Vue.swal({
                            icon: 'success',
                            title: '¡Great!',
                            text: 'Password Reset Email Sent Succesffully.',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true,
                        });
                        this.$router.push('/login');
                    })
                    .catch(function (error) {
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'Authentication Error.',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
            }
        }
    }
}
</script>
