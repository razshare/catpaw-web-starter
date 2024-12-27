/**
 * @template T
 * @typedef {[T,Error]} Result
 */

/**
 * @template [T=any]
 * @param {T} [value]
 * @returns {Result<any>}
 */
function success(value) {
  // @ts-ignore
  return [value, undefined]
}

/**
 * @param {any} error
 * @returns {Result<any>}
 */
function failure(error) {
  if (error instanceof Error) {
    return [undefined, error]
  }

  return [undefined, new Error(`${error}`)]
}

const EMPTY = success()

export const result = { success, failure, EMPTY }
