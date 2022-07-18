<template>
    <div class="panel panel-default">
        <h1 class="panel-heading">Связаться со мной</h1>
        <div class="panel-body">
            <form @submit.prevent="saveForm()">
                <div class="d-flex flex-lg-row flex-column">
                    <div class="d-flex flex-column col-12">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">ФИО</label>
                            <input :class="{'is-invalid': errors.name, 'is-valid': form.name}" @change="changeInput('name')" type="text" v-model="form.name" class="form-control">
                            <p class="mb-0 text-danger" v-for="error in errors.name" :key="error" v-html="error" />
                        </div>

                        <div class="col-xs-12 form-group">
                            <label class="control-label">Email</label>
                            <input :class="{'is-invalid': errors.email, 'is-valid': form.email}" @change="changeInput('email')" type="text" v-model="form.email" class="form-control">
                            <p class="mb-0 text-danger" v-for="error in errors.email" :key="error" v-html="error" />
                        </div>

                        <div class="col-xs-12 form-group">
                            <label class="control-label">Телефон</label>
                            <input :class="{'is-invalid': errors.phone, 'is-valid': form.phone}" @change="changeInput('phone')" type="text" v-model="form.phone" class="form-control">
                            <p class="mb-0 text-danger" v-for="error in errors.phone" :key="error" v-html="error" />
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="col-xs-12 form-group">
                        <button class="btn btn-success">Отправить</button>
                    </div>
                </div>

                <div class="col-12 col-lg-6" v-if="success">
                    <p class="text-success" v-html="success" />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { FEEDBACK_SEND } from '../../api-routes';
    export default {
        data: function () {
            return {
                form: {
                    name: null,
                    email: null,
                    phone: null,
                },
                errors: {
                    name: null,
                    email: null,
                    phone: null,
                },
                success: null,
            }
        },
        methods: {
            saveForm() {
                let app = this,
                    data = this.clearInputs(app.form);

                axios.post(FEEDBACK_SEND, data)
                    .then(function (res) {
                        if(res.status === 200) {
                            app.success = 'Данные успешно отправлены!';
                        }
                    })
                    .catch(function (res) {
                        if(res !== undefined && res.response.data.errors !== undefined)
                        app.errors = res.response.data.errors;
                    });
            },
            changeInput(input) {
                this.errors[input] = null;
                console.log(this.errors);
            },
            clearInputs(data){
                let arr = data;

                Object.keys(arr)
                    .map((key) => {
                        if(arr[key] === '' || arr[key] === null) {
                            delete(arr[key]);
                        }
                    });

                return arr;
            },
        }
    }
</script>
