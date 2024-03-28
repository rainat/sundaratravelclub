import { useState } from 'preact/hooks'
import Router from 'preact-router';
const { createHashHistory } = History

function MyAccount()
{
    return <h1>My Account Page</h1>
}

function Booking()
{
  return <h1>Booking Page</h1>
}

export function App() {
  const [count, setCount] = useState(0)

  return (
   
      <Router history={createHashHistory()}>
        <MyAccount path="/"/>
        <Booking path="/booking"/>
    </Router>
  )
}
