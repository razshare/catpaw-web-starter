/**
 * @param {import("$lib/types").Result<any>} error
 */
export function error(error) {
  return [undefined, error]
}
