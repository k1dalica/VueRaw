import * as types from './types'
import userApi from '../../services/api/user'

const state = {
    token: null,
    logged: false
}

const getters = {
    token: store => store.token,
    logged: store => store.logged
}

const actions = {
    getLikes ({state, commit}, payload) {
        return userApi.getLikes(payload)
            .then(data => {
                return data.data.data
            })
            .catch(error => {
                console.log(error + 'get likes error')
            })
    },
    logout ({state, commit}) {
        window.localStorage.removeItem('token')  
        commit(types.SET_TOKEN, '')
        commit(types.SET_LOGGED, false)
    }
}
const mutations = {
    [types.SET_TOKEN] (state, data) {
        state.token = data
    },
    [types.SET_LOGGED] (state, data) {
        state.logged = data
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
  
  const initialStateCopy = JSON.parse(JSON.stringify(state))