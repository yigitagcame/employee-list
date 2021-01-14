<template>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert" v-if="error">
                Please make sure all your inputs are valid!
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"><b>Add an Employee</b> <a class="btn btn-primary" href="/">Back to List</a></div>

                    <div class="card-body">

                        <form v-on:submit.prevent="submitForm()">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" placeholder="Name" v-model="employee.name" required>
                            </div>
                            <div class="form-group">
                                <label>Surname</label>
                                <input class="form-control" placeholder="Surname" v-model="employee.surname" required>
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea class="form-control" rows="3" v-model="employee.comment"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" ref="file" class="form-control-file" required>
                                <small id="emailHelp" class="form-text text-muted">Max 2048 KB. JPG, JPEG or PNG</small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                employee: {
                    name: '',
                    surname: '',
                    comment: ''
                },
                error: 0
            }
        },
        methods: {
            submitForm(){
                let formData = new FormData();
                let self = this;

                formData.append('name', this.employee.name);
                formData.append('surname', this.employee.surname);
                formData.append('comment', this.employee.comment);
                formData.append('photo', this.$refs.file.files[0]);

                axios.post('/api/employee',
                    formData,
                    {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                ).then(function(data){
                    self.$router.push({path: '/'});
                })
                .catch(function(){
                    self.error = 1;
                    setTimeout(() => self.error = 0, 3000 );
                });
            }
        }
    }
</script>
