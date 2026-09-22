package com.example.bumiyuji.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Add
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material3.*
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import coil.compose.AsyncImage
import com.example.bumiyuji.ui.UiState
import com.example.bumiyuji.ui.components.BumiyujiLoading
import com.example.bumiyuji.ui.components.BumiyujiTopBar
import com.example.bumiyuji.ui.theme.GoldAccent
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.TeamViewModel
import com.example.bumiyuji.util.ImageUtils

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun TeamListScreen(
    viewModel: TeamViewModel,
    onBackClick: () -> Unit,
    onNavigateToAdd: () -> Unit,
    onNavigateToEdit: (Int) -> Unit
) {
    LaunchedEffect(Unit) {
        viewModel.fetchTeamProfiles()
    }

    Scaffold(
        topBar = {
            BumiyujiTopBar(title = "Anggota Tim", onBackClick = onBackClick)
        },
        floatingActionButton = {
            LargeFloatingActionButton(
                onClick = onNavigateToAdd,
                containerColor = MaterialTheme.colorScheme.primary,
                contentColor = Color.White
            ) {
                Icon(Icons.Default.Add, contentDescription = "Add Member")
            }
        },
        containerColor = WarmCream
    ) { innerPadding ->
        val uiState = viewModel.uiState

        Box(modifier = Modifier.padding(innerPadding).fillMaxSize()) {
            when (uiState) {
                is UiState.Loading -> BumiyujiLoading()
                is UiState.Error -> Text(text = uiState.message, modifier = Modifier.align(Alignment.Center))
                is UiState.Success -> {
                    if (uiState.data.isEmpty()) {
                        Text(text = "Belum ada anggota tim", modifier = Modifier.align(Alignment.Center), color = Color.Gray)
                    } else {
                        LazyColumn(
                            contentPadding = PaddingValues(16.dp),
                            verticalArrangement = Arrangement.spacedBy(12.dp)
                        ) {
                            items(uiState.data) { profile ->
                                Card(
                                    onClick = { onNavigateToEdit(profile.id) },
                                    modifier = Modifier.fillMaxWidth(),
                                    shape = RoundedCornerShape(16.dp),
                                    colors = CardDefaults.cardColors(containerColor = Color.White),
                                    elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
                                ) {
                                    Row(
                                        modifier = Modifier.padding(16.dp),
                                        verticalAlignment = Alignment.CenterVertically
                                    ) {
                                        AsyncImage(
                                            model = ImageUtils.resolveImageUrl(profile.image_url),
                                            contentDescription = null,
                                            modifier = Modifier
                                                .size(60.dp)
                                                .clip(CircleShape)
                                                .background(WarmCream),
                                            contentScale = ContentScale.Crop
                                        )

                                        Spacer(modifier = Modifier.width(16.dp))

                                        Column(modifier = Modifier.weight(1f)) {
                                            Text(
                                                text = profile.name,
                                                style = MaterialTheme.typography.titleMedium,
                                                fontWeight = FontWeight.Bold
                                            )
                                            Text(
                                                text = profile.position ?: "No position",
                                                style = MaterialTheme.typography.bodySmall,
                                                color = Color.Gray
                                            )
                                        }

                                        IconButton(onClick = { viewModel.deleteTeamProfile(profile.id) }) {
                                            Icon(
                                                Icons.Default.Delete,
                                                contentDescription = "Delete",
                                                tint = MaterialTheme.colorScheme.error.copy(alpha = 0.6f)
                                            )
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else -> {}
            }
        }
    }
}
