window.createUser = () => {
    return {
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        role: 'Role',

        submitUser() {
            let data = new FormData()
            data.append('email', this.email)
            data.append('first_name', this.first_name)
            data.append('last_name', this.last_name)
            data.append('password', this.password)
            data.append('role', this.role == "Role" ? '' : this.role)
            axios.post('/user/create', data).then(res => console.log(res)).catch(err => console.log(err))
        }
    }
}