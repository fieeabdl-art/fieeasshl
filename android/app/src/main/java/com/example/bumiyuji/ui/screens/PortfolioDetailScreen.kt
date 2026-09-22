package com.example.bumiyuji.ui.screens

import androidx.compose.animation.*
import androidx.compose.animation.core.*
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.horizontalScroll
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material.icons.filled.Edit
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.draw.scale
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import coil.compose.AsyncImage
import com.example.bumiyuji.ui.UiState
import com.example.bumiyuji.ui.components.BumiyujiLoading
import com.example.bumiyuji.ui.theme.DarkCharcoal
import com.example.bumiyuji.ui.theme.GoldAccent
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.PortfolioViewModel
import com.example.bumiyuji.util.ImageUtils
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun PortfolioDetailScreen(
    viewModel: PortfolioViewModel,
    portfolioId: Int,
    onNavigateBack: () -> Unit,
    onNavigateToEditPortfolio: (Int) -> Unit,
    onNavigateToEditPhase: (Int, Int) -> Unit
) {
    LaunchedEffect(portfolioId) {
        viewModel.fetchDetail(portfolioId)
    }

    val uiState = viewModel.detailUiState
    val scrollState = rememberScrollState()

    Scaffold(
        containerColor = WarmCream
    ) { innerPadding ->
        Box(modifier = Modifier.padding(innerPadding).fillMaxSize()) {
            when (uiState) {
                is UiState.Loading -> BumiyujiLoading()
                is UiState.Error -> Text(text = uiState.message, modifier = Modifier.align(Alignment.Center))
                is UiState.Success -> {
                    val portfolio = uiState.data

                    var visible by remember { mutableStateOf(false) }
                    LaunchedEffect(Unit) {
                        visible = true
                    }

                    Column(
                        modifier = Modifier
                            .fillMaxSize()
                            .verticalScroll(scrollState)
                    ) {
                        // Header with Image
                        Box {
                            AsyncImage(
                                model = ImageUtils.resolveImageUrl(portfolio.image_url),
                                contentDescription = null,
                                modifier = Modifier
                                    .fillMaxWidth()
                                    .height(350.dp),
                                contentScale = ContentScale.Crop
                            )

                            IconButton(
                                onClick = onNavigateBack,
                                modifier = Modifier.padding(16.dp).background(Color.Black.copy(alpha = 0.3f), RoundedCornerShape(12.dp))
                            ) {
                                Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back", tint = Color.White)
                            }

                            IconButton(
                                onClick = { onNavigateToEditPortfolio(portfolioId) },
                                modifier = Modifier
                                    .align(Alignment.TopEnd)
                                    .padding(16.dp)
                                    .background(Color.Black.copy(alpha = 0.3f), RoundedCornerShape(12.dp))
                            ) {
                                Icon(Icons.Default.Edit, contentDescription = "Edit Portfolio", tint = Color.White)
                            }
                        }

                        AnimatedVisibility(
                            visible = visible,
                            enter = fadeIn(animationSpec = tween(1000)) + slideInVertically(initialOffsetY = { 50 })
                        ) {
                            Column(modifier = Modifier.padding(24.dp)) {
                                Surface(
                                    shape = RoundedCornerShape(8.dp),
                                    color = GoldAccent.copy(alpha = 0.1f)
                                ) {
                                    Text(
                                        text = portfolio.category_label,
                                        modifier = Modifier.padding(horizontal = 12.dp, vertical = 6.dp),
                                        style = MaterialTheme.typography.labelLarge,
                                        color = GoldAccent,
                                        fontWeight = FontWeight.Bold
                                    )
                                }

                                Spacer(modifier = Modifier.height(16.dp))

                                Text(
                                    text = portfolio.title,
                                    style = MaterialTheme.typography.headlineMedium,
                                    fontWeight = FontWeight.Bold,
                                    color = DarkCharcoal
                                )

                                Spacer(modifier = Modifier.height(24.dp))

                                Text(
                                    text = "Deskripsi Proyek",
                                    style = MaterialTheme.typography.titleMedium,
                                    fontWeight = FontWeight.Bold
                                )

                                Spacer(modifier = Modifier.height(8.dp))

                                Text(
                                    text = portfolio.description ?: "Tidak ada deskripsi",
                                    style = MaterialTheme.typography.bodyLarge,
                                    color = Color.DarkGray
                                )

                                // Phases section
                                if (!portfolio.phases.isNullOrEmpty()) {
                                    Spacer(modifier = Modifier.height(40.dp))
                                    Text(
                                        text = "Progres Pengerjaan",
                                        style = MaterialTheme.typography.titleLarge,
                                        fontWeight = FontWeight.Bold
                                    )
                                    Spacer(modifier = Modifier.height(24.dp))

                                    portfolio.phases.forEachIndexed { index, phase ->
                                        var phaseVisible by remember { mutableStateOf(false) }
                                        LaunchedEffect(Unit) {
                                            delay(200L * (index + 1))
                                            phaseVisible = true
                                        }

                                        AnimatedVisibility(
                                            visible = phaseVisible,
                                            enter = fadeIn(animationSpec = tween(600)) + slideInVertically(initialOffsetY = { 30 })
                                        ) {
                                            PhaseItem(
                                                phase = phase,
                                                onEditClick = { onNavigateToEditPhase(portfolio.id, phase.id) },
                                                isLast = index == portfolio.phases.size - 1
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

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun PhaseItem(
    phase: com.example.bumiyuji.data.api.PortfolioPhaseDto,
    onEditClick: () -> Unit,
    isLast: Boolean
) {
    var pressed by remember { mutableStateOf(false) }
    val scale by animateFloatAsState(if (pressed) 0.98f else 1f, label = "scale")
    val elevation by animateDpAsState(if (pressed) 1.dp else 4.dp, label = "elevation")

    // Progress bar animation
    val progressAnim = remember { Animatable(0f) }
    LaunchedEffect(Unit) {
        progressAnim.animateTo(
            targetValue = phase.percentage / 100f,
            animationSpec = tween(durationMillis = 1500, easing = FastOutSlowInEasing)
        )
    }

    Row(modifier = Modifier.fillMaxWidth()) {
        // Vertical Timeline
        Column(horizontalAlignment = Alignment.CenterHorizontally) {
            Surface(
                modifier = Modifier.size(44.dp).scale(if (phase.percentage > 0) 1f else 0.9f),
                shape = RoundedCornerShape(12.dp),
                color = if (phase.percentage == 100) GoldAccent else DarkCharcoal,
                shadowElevation = 4.dp
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Text(
                        text = "${phase.percentage}%",
                        color = if (phase.percentage == 100) DarkCharcoal else GoldAccent,
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Bold
                    )
                }
            }
            if (!isLast) {
                Box(
                    modifier = Modifier
                        .width(2.dp)
                        .height(120.dp)
                        .background(
                            brush = androidx.compose.ui.graphics.Brush.verticalGradient(
                                colors = listOf(Color.LightGray, Color.Transparent)
                            )
                        )
                )
            }
        }

        Spacer(modifier = Modifier.width(20.dp))

        Card(
            onClick = onEditClick,
            modifier = Modifier
                .fillMaxWidth()
                .padding(bottom = 32.dp)
                .scale(scale),
            shape = RoundedCornerShape(20.dp),
            colors = CardDefaults.cardColors(containerColor = Color.White),
            elevation = CardDefaults.cardElevation(defaultElevation = elevation)
        ) {
            Column(modifier = Modifier.padding(20.dp)) {
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Text(
                        text = phase.title,
                        style = MaterialTheme.typography.titleMedium,
                        fontWeight = FontWeight.Bold,
                        modifier = Modifier.weight(1f)
                    )
                    Icon(Icons.Default.Edit, contentDescription = "Edit Phase", modifier = Modifier.size(20.dp), tint = GoldAccent)
                }

                if (!phase.description.isNullOrEmpty()) {
                    Spacer(modifier = Modifier.height(8.dp))
                    Text(
                        text = phase.description,
                        style = MaterialTheme.typography.bodyMedium,
                        color = Color.Gray
                    )
                }

                if (!phase.images.isNullOrEmpty()) {
                    Spacer(modifier = Modifier.height(16.dp))
                    Row(
                        modifier = Modifier.horizontalScroll(rememberScrollState()),
                        horizontalArrangement = Arrangement.spacedBy(10.dp)
                    ) {
                        phase.images.forEachIndexed { imgIndex, img ->
                            var imgVisible by remember { mutableStateOf(false) }
                            LaunchedEffect(Unit) {
                                delay(100L * imgIndex)
                                imgVisible = true
                            }

                            AnimatedVisibility(
                                visible = imgVisible,
                                enter = fadeIn() + scaleIn(initialScale = 0.95f)
                            ) {
                                AsyncImage(
                                    model = ImageUtils.resolveImageUrl(img.image_url),
                                    contentDescription = null,
                                    modifier = Modifier
                                        .size(100.dp)
                                        .clip(RoundedCornerShape(12.dp))
                                        .background(WarmCream),
                                    contentScale = ContentScale.Crop
                                )
                            }
                        }
                    }
                }

                Spacer(modifier = Modifier.height(16.dp))
                LinearProgressIndicator(
                    progress = { progressAnim.value },
                    modifier = Modifier.fillMaxWidth().height(4.dp).clip(RoundedCornerShape(2.dp)),
                    color = GoldAccent,
                    trackColor = WarmCream
                )
            }
        }
    }
}
