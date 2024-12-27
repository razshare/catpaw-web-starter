<script module>
  import { http } from '$lib/scripts/http'
  http.get('/api/counter').then(function then([value, error]) {
    if (error) {
      console.error(error)
    } else {
      count = value
    }
  })

  let count = $state(0)
</script>

<script>
  async function increment() {
    const [value, error] = await http.get('/api/counter/increase')
    if (error) {
      console.error(error)
      return
    }
    count = value
  }
</script>

<button onclick={increment}>
  count is {count}
</button>
