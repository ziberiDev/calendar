
window.nav = () => {
    return {
        users: null,

        getUsers() {
            axios.get('/users')
                .then(data => this.users = data.data.items)
                .catch(err => console.log(err))
        }
    }
}