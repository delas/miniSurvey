CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `code` varchar(256) NOT NULL,
  `step` varchar(256) NOT NULL,
  `answer` text NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
