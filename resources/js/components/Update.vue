<template>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert" v-if="error">
                Please make sure all your inputs are valid!
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"><b>Edit an Employee</b> <a class="btn btn-primary" href="/">Back to List</a></div>

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
                                <div><img v-bind:src="'/uploads/'+employee.photo"></div>
                                <input type="file" ref="file" class="form-control-file">
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
                    comment: '',
                    photo: '',
                    id: ''
                },
                error: 0
            }
        },
        mounted() {
            let self = this;
            let id = self.$route.params.id;

            axios.get('/api/employee/' + id)
                .then(function (res) {
                    self.employee = res.data;
                })
                .catch(function () {
                    alert("Could not load your company")
                });
        },
        methods: {
            submitForm(){
                let formData = new FormData();
                let self = this;

                let photo = this.$refs.file.files[0];

                formData.append('name', this.employee.name);
                formData.append('surname', this.employee.surname);
                formData.append('comment', this.employee.comment);

                if(photo){
                    formData.append('photo', photo);
                }


                formData.append('_method', 'PATCH');

                axios.post('/api/employee/'+this.employee.id,
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
