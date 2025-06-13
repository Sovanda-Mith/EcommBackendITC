import { Module } from '@nestjs/common';
import { AttendanceResolver } from './attendance.resolver';
import { registerEnumType } from '@nestjs/graphql';
import { AttendanceStatus } from './attendance-status.enum';

registerEnumType(AttendanceStatus, {
  name: 'AttendanceStatus',
});

@Module({
  imports: [],
  controllers: [],
  providers: [AttendanceResolver],
})
export class AttendanceModule {}
