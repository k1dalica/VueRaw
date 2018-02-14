import axios from 'axios'

export default {
    userLogged
}

function userLogged () {
    let token = window.localStorage.getItem('token')
    if(token !== null) {
        axios.get('http://k1d.local/api/login/'+token).then(function (res) {
            return res.data.msg
        }).catch(function (error) {
            return false
        })
    } else {
        return false
    }
}
