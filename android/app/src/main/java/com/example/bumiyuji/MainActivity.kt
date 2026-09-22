package com.example.bumiyuji

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.padding
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Surface
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.ui.Modifier
import androidx.navigation.compose.rememberNavController
import com.example.bumiyuji.ui.navigation.NavGraph
import com.example.bumiyuji.ui.navigation.Screen
import com.example.bumiyuji.ui.theme.BumiyujiTheme
import kotlinx.coroutines.flow.collectLatest

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        val application = application as BumiyujiApplication
        setContent {
            BumiyujiTheme {
                val navController = rememberNavController()

                LaunchedEffect(Unit) {
                    application.sessionManager.sessionExpiredEvent.collectLatest { expired ->
                        if (expired) {
                            navController.navigate(Screen.Login.route) {
                                popUpTo(0) { inclusive = true }
                            }
                        }
                    }
                }

                Surface(
                    modifier = Modifier.fillMaxSize(),
                    color = MaterialTheme.colorScheme.background
                ) {
                    NavGraph(navController = navController, application = application)
                }
            }
        }
    }
}
