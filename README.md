GraphPinatra
-----

GraphQL framework with Eloquent.

## Example

#### git clone or download manually

#### run with PHP -S

```bash
cd GraphPinatra
php -S 0.0.0.0:8000 -t public
```

#### input

open the url below with your browser:

```bash
http://0.0.0.0:8000/graphql.php?debug=1&query={article(id:1){id,title,read_count}}
```

or use [ChromeiQL Chrome app](https://chrome.google.com/webstore/detail/chromeiql/fkkiamalmpiidkljmicmjfbieiclmeij) with:

```js
{
  article(id: 1) {
    id
    title
    read_count
  }
}
```

#### result

```json
{
  "data": {
    "article": {
      "id": 1,
      "title": "ooxx",
      "read_count": 0
    }
  }
}
```