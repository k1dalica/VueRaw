export default function (url, filename, mimeType) {
  return (fetch(url)
    .then(res => res.arrayBuffer())
    .then(buffer => {
      return new File([buffer], filename, {type: mimeType})
    })
  )
}

export function fileToBase64 (file) {

}
