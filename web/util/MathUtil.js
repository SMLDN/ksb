const base = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

/**
 * Convert a from a given base to base 10.
 *
 * @param  string  value
 * @param  int     base
 * @return int
 */
export function toBase10(value, b = 62) {
    const limit = value.length;
    let result = base.indexOf(value[0]);
    for (let i = 1; i < limit; i++) {
        result = b * result + base.indexOf(value[i]);
    }
    return result;
}

/**
 * Convert from base 10 to another base.
 *
 * @param  int     value
 * @param  int     base
 * @return string
 */
export function toBase(value, b = 62) {
    let r = value % b;
    let result = base[r];
    let q = Math.floor(value / b);
    while (q) {
        r = q % b;
        q = Math.floor(q / b);
        result = base[r] + result;
    }
    return result;
}
