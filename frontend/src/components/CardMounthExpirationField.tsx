import { Stack, TextField } from '@mui/material'

export const CardMounthExpirationField = () => {
    return (
        <Stack sx={{marginTop: 2}}>
            <Stack direction={'row'} spacing={202}>
                <TextField label='Mes de expiracao (MM)' />
            </Stack>
        </Stack>
    )
}