import { FormControl, FilledInput, InputAdornment } from '@mui/material'

export const PaymentValueField = () => {
    return (
        <FormControl sx={{marginTop: 2}}>
          <FilledInput
            id="filled-adornment-amount"
            startAdornment={<InputAdornment position="start">R$</InputAdornment>}
          />
        </FormControl>
    )
}