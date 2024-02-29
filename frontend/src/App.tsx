import { Grid, Typography } from '@mui/material';
import './App.css';
import { PayerEmailField } from './components/PayerEmailField';
import { IdentificationFields } from './components/IdentificationFields';
import { PaymentValueField } from './components/PaymentValueField';
import { CardNumberField } from './components/CardNumberField';
import { CardMounthExpirationField } from './components/CardMounthExpirationField';
import { CardYearExpirationField } from './components/CardYearExpirationField';
import { CardSecurityDigit } from './components/CardSecurityDigit';
import { InstallmentsField } from './components/InstallmentsField';
import { createTokenCard } from './services/createTokenCard'

function App() {
  createTokenCard()
  return (
    <Grid 
      container sx={{marginLeft: 15, marginTop: 5, alignContent: 'center'}}>
      <Grid item xs={4}>
          <Typography variant='h5'>Dados do Pagador</Typography>
          <PayerEmailField />
          <IdentificationFields />
      </Grid>

      <Grid item xs={8}>
          <Typography variant='h5'>Dados do Pagamento</Typography>
          <PayerEmailField />
          <PaymentValueField />
          <CardNumberField />
          <CardMounthExpirationField />
          <CardYearExpirationField />
          <CardSecurityDigit />
          <InstallmentsField />
      </Grid>
    </Grid>
  );
}

export default App;