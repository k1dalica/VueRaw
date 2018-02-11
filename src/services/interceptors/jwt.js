import jwtDecode from 'jwt-decode'
import config from '../../config'

const JWT_TOKEN_NAME = config.jwtTokenName

export default function jwtInterceptor (request, next) {
  const token = window.localStorage.getItem(JWT_TOKEN_NAME)

  if (token !== null && token !== 'undefined') {
    request.headers.set('Authorization', 'Bearer ' + token)
  }

  next(response => {
    if (response.body && response.body.token) {
      const tokenData = jwtDecode(response.body.token.token)
      if (tokenData.email && tokenData.active) {
        window.localStorage.setItem(JWT_TOKEN_NAME, response.body.token)
      }
    }
  })
}
