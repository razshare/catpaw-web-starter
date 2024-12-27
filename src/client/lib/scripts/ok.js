/**
 * @template [T=any]
 * @param {import("$lib/types").Result<T>} value
 */
export function ok(value) {
  return [value, undefined]
}
