import config from '../config'

export let http = null

export function initHttpService (context) {
  http = context.http
  http.options.root = config.apiRoot
}

export function responseTransformer (response) {
  return response.body
}
