import axios from 'axios'

export default {
    getToken
}

function getToken () {
    let token = JSON.parse(window.localStorage.getItem('token'))
    if(token !== null) {
        let params = new URLSearchParams()
        params.append('token', token)
        axios.post('http://k1d.local/api/login', params).then(function (res) {
         return res.data.msg
        }).catch(function (error) {
          console.log(error)
        })
    }
    return false
}
