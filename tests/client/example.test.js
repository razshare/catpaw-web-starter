import { result } from '$lib/scripts/result'
import { expect, test } from 'vitest'

test('create a successful result', function run() {
  const expected = 'ok'
  const [actualValue, actualError] = result.success(expected)
  expect(actualError).toBeUndefined()
  expect(actualValue).toBe(expected)
})

test('create a failure result', function run() {
  const expected = 'this is an error message'
  const [actualValue, actualError] = result.failure(expected)
  expect(actualValue).toBeUndefined()
  expect(actualError).toBeDefined()
  expect(actualError.message).toBe(expected)
})
