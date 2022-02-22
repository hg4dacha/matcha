import { BrowserRouter, Route, Switch } from 'react-router-dom';
import Home from './components/Home/Home';
import SignIn from './components/SignIn/SignIn';
import SignUp from './components/SignUp/SignUp';
import ForgotPassword from './components/ForgotPassword/ForgotPassword';
import NewPassword from './components/NewPassword/NewPassword';
import CompleteProfile from './components/CompleteProfile/CompleteProfile';
import Profile from './components/Profile/Profile';
import Main from './components/Main/Main';
import MemberProfile from './components/MemberProfile/MemberProfile';
import NotFound from './components/NotFound/NotFound';
import Footer from './components/Footer/Footer';
import './App.css';



function App() {

  return (
    <BrowserRouter>
    
      <Switch>
        <Route exact path='/' component={Home} />
        <Route path='/SignUp' component={SignUp} />
        <Route path='/SignIn' component={SignIn} />
        <Route path='/ForgotPassword' component={ForgotPassword} />
        <Route path='/NewPassword' component={NewPassword} />
        <Route path='/CompleteProfile' component={CompleteProfile} />
        <Route path='/Main' component={Main} />
        <Route path='/Profile' component={Profile} />
        <Route path='/MemberProfile' component={MemberProfile} />
        <Route component={NotFound} />
      </Switch>
      
      <Footer/>
    </BrowserRouter>
  );
}

export default App;