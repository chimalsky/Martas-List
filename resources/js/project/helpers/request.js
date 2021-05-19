import { Request } from "@lib/http/request"

export async function request(method, url, options) {
  const request = new Request(method, url, options)
  const response = await request.perform()
  if (!response.ok) throw new Error(response.statusCode)
  return request.responseKind == "json"
    ? response.json
    : response.text
}

[ "get", "post", "put", "delete" ].forEach(method => {
  request[method] = (...args) => request(method, ...args)
})

request.getJSON = (url, options = {}) => request.get(url, { responseKind: "json", ...options })
