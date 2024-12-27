import { result } from '$lib/scripts/result'

/**
 *
 * @param {string} path
 * @param {Record<string,string>} headers
 */
async function get(path, headers = {}) {
  try {
    const response = await fetch(path, { method: 'GET', headers })

    if (response.status >= 300) {
      return result.failure(
        `Request failed with status "${response.status} ${response.statusText}".`,
      )
    }

    return result.success(await response.text())
  } catch (error) {
    return result.failure(error)
  }
}

/**
 *
 * @param {string} path
 * @param {Record<string,string>} headers
 */
async function remove(path, headers = {}) {
  try {
    const response = await fetch(path, { method: 'DELETE', headers })

    if (response.status >= 300) {
      return result.failure(
        `Request failed with status "${response.status} ${response.statusText}".`,
      )
    }

    return result.success(await response.text())
  } catch (error) {
    return result.failure(error)
  }
}

/**
 *
 * @param {string} path
 * @param {string} body
 * @param {Record<string,string>} headers
 */
async function post(path, body, headers = {}) {
  try {
    const response = await fetch(path, { method: 'POST', headers, body })

    if (response.status >= 300) {
      return result.failure(
        `Request failed with status "${response.status} ${response.statusText}".`,
      )
    }

    return result.success(await response.text())
  } catch (error) {
    return result.failure(error)
  }
}

/**
 *
 * @param {string} path
 * @param {string} body
 * @param {Record<string,string>} headers
 */
async function put(path, body, headers = {}) {
  try {
    const response = await fetch(path, { method: 'PUT', headers, body })

    if (response.status >= 300) {
      return result.failure(
        `Request failed with status "${response.status} ${response.statusText}".`,
      )
    }

    return result.success(await response.text())
  } catch (error) {
    return result.failure(error)
  }
}

/**
 *
 * @param {string} path
 * @param {string} body
 * @param {Record<string,string>} headers
 */
function postJson(path, body, headers = {}) {
  return post(path, body, { ...headers, 'Content-Type': 'application/json' })
}

/**
 *
 * @param {string} path
 * @param {string} body
 * @param {Record<string,string>} headers
 */
function putJson(path, body, headers = {}) {
  return put(path, body, { ...headers, 'Content-Type': 'application/json' })
}

export const http = { get, delete: remove, post, put, postJson, putJson }
