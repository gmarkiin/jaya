import { Button, Grid, Typography } from "@mui/material";
import "./App.css";
import { PayerEmailField } from "./components/PayerEmailField";
import { IdentificationFields } from "./components/IdentificationFields";
import { PaymentValueField } from "./components/PaymentValueField";
import { CardNumberField } from "./components/CardNumberField";
import { CardMounthExpirationField } from "./components/CardMounthExpirationField";
import { CardYearExpirationField } from "./components/CardYearExpirationField";
import { CardSecurityDigit } from "./components/CardSecurityDigit";
import { InstallmentsField } from "./components/InstallmentsField";
import { useState } from "react";
import { createCardToken } from "@mercadopago/sdk-react/coreMethods";
import { fetchPaymentMethodsOptions } from "./services/getPaymentMethod"

function App() {

  fetchPaymentMethodsOptions('50314332')
  const [loading, setLoading] = useState(false);

  const handlePayment = async () => {
    setLoading(true);
    try {
      const response = await createCardToken({
        cardNumber: "5031433215406351",
        cardholderName: "Marcos",
        cardExpirationMonth: "11",
        cardExpirationYear: "25",
        securityCode: "123",
        identificationNumber: "12345678909",
        identificationType: "CPF",
      });
      console.log("🚀 ~ handlePayment ~ response:", response);
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  return (
    <Grid
      container
      sx={{ marginLeft: 15, marginTop: 5, alignContent: "center" }}
    >
      <Grid item xs={4}>
        <Typography variant="h5">Dados do Pagador</Typography>
        <PayerEmailField />
        <IdentificationFields />
      </Grid>

      <Grid item xs={8}>
        <Typography variant="h5">Dados do Pagamento</Typography>
        <PaymentValueField />
        <CardNumberField />
        <CardMounthExpirationField />
        <CardYearExpirationField />
        <CardSecurityDigit />
        <InstallmentsField />
      </Grid>

      <Grid item xs={12}>
        <Button
          disabled={loading}
          color="success"
          variant="contained"
          onClick={handlePayment}
        >
          Pagar
        </Button>
      </Grid>
    </Grid>
  );
}

export default App;
