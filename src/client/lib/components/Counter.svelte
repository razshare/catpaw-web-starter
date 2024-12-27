<script module>
  import { http } from '$lib/scripts/http'

  let [value, error] = await http.get('/api/counter')

  if (error) {
    console.error(error)
    value = 0
  }

  let count = $state(value)
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
